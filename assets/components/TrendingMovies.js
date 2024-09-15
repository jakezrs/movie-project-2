import React, { useState, useEffect } from 'react';
import SearchMovies from './SearchMovies';

function TrendingMovies() {
  const [movies, setMovies] = useState([]);
  const [loading, setLoading] = useState(true);
  const [timeWindow, setTimeWindow] = useState('day');

  useEffect(() => {
    const fetchTrendingMovies = async () => {
      setLoading(true);
      const response = await fetch(`/api/movies/trending/${timeWindow}`);
      const data = await response.json();
      console.log(data);
      setMovies(data);
      setLoading(false);
    };

    fetchTrendingMovies();
  }, [timeWindow]);

  return (
    <div>
      <SearchMovies/>
      <h2>Films tendances ({timeWindow === 'day' ? 'Aujourd\'hui' : 'Cette semaine'})</h2>
      <div>
        <button 
          onClick={() => setTimeWindow('day')} 
          disabled={timeWindow === 'day'}
        >
          Aujourd'hui
        </button>
        <button 
          onClick={() => setTimeWindow('week')} 
          disabled={timeWindow === 'week'}
        >
          Cette semaine
        </button>
      </div>
      {loading ? (
        <p>Chargement...</p>
      ) : (
        <div style={{ whiteSpace: 'nowrap', overflowX: 'auto' }}>
          {movies.map(movie => (
              <div key={movie.id} style={{ display: 'inline-block', marginRight: '20px' }}>
                <a href={`/movies/${movie.id}`}>
                <img src={`https://image.tmdb.org/t/p/w300${movie.posterPath}`} alt={movie.title} />
                </a>
              <h3>{movie.title}</h3>
              <p>{movie.releaseDate}</p>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

export default TrendingMovies;