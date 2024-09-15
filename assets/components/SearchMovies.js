import React, { useState } from 'react';

function SearchMovies() {
  const [query, setQuery] = useState('');
  const [movies, setMovies] = useState([]);
  const [loading, setLoading] = useState(false);

  const handleSearch = async (event) => {
    event.preventDefault();
    setLoading(true);

    const response = await fetch(`/api/search/movie?query=${query}`);
    const data = await response.json();
    setMovies(data.results);
    setLoading(false);
  };

  return (
    <div style={{ textAlign: 'center'}}>
      <h2>Recherche</h2>
      <form onSubmit={handleSearch}>
        <input 
          type="text" 
          placeholder="Rechercher un film..." 
          value={query} 
          onChange={(e) => setQuery(e.target.value)}
        />
        <button type="submit">Search</button>
      </form>

      {loading ? (
        <p>Loading...</p>
      ) : (
        <div className="movie-grid">
          {movies.length > 0 ? (
            movies.map(movie => (
              <div key={movie.id} className="movie-card">
                <a href={`/movie/${movie.id}`}>
                  <img
                    src={`https://image.tmdb.org/t/p/w500${movie.poster_path}`}
                    alt={movie.title}
                  />
                </a>
                <h3>{movie.title}</h3>
                <p>{movie.release_date}</p>
              </div>
            ))
          ) : (
            <p>Aucun résultat.</p>
          )}
        </div>
      )}
    </div>
  );
}

export default SearchMovies;