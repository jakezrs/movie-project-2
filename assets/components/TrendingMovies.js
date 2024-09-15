import React, { useState, useEffect } from 'react';

function TrendingMovies() {
  const [movies, setMovies] = useState([]);
  const [loading, setLoading] = useState(true);
  const [timeWindow, setTimeWindow] = useState('day');

  useEffect(() => {
    const fetchTrendingMovies = async () => {
      setLoading(true);
      const response = await fetch(`/api/movies/trending/${timeWindow}`);
      const data = await response.json();
      setMovies(data);
      setLoading(false);
    };

    fetchTrendingMovies();
  }, [timeWindow]);

  return (
    <div>
      <h1>Films tendances ({timeWindow === 'day' ? 'Aujourd\'hui' : 'Ce mois-ci'})</h1>
      <div>
        <button 
          onClick={() => setTimeWindow('day')} 
          disabled={timeWindow === 'day'}
        >
          Today
        </button>
        <button 
          onClick={() => setTimeWindow('week')} 
          disabled={timeWindow === 'week'}
        >
          This Month
        </button>
      </div>
      {loading ? (
        <p>Loading...</p>
      ) : (
        <div className="movie-grid">
          {movies.map(movie => (
            <div key={movie.id} className="movie-card">
              <img
                src={`https://image.tmdb.org/t/p/w500${movie.poster_path}`}
                alt={movie.title}
              />
              <h3>{movie.title}</h3>
              <p>{movie.release_date}</p>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

export default TrendingMovies;