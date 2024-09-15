import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
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
      setMovies(data);
      setLoading(false);
    };

    fetchTrendingMovies();
  }, [timeWindow]);

  return (
    <div>
      <SearchMovies/>
      <h2>Films tendances ({timeWindow === 'day' ? 'Aujourd\'hui' : 'Ce mois-ci'})</h2>
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
          Ce-mois-ci
        </button>
      </div>
      {loading ? (
        <p>Chargement...</p>
      ) : (
        <div className="movie-grid">
          {movies.map(movie => (
            <div key={movie.id} className="movie-card">
                <a href={`/movies/${movie.id}`}>
                  <img
                    src={`https://image.tmdb.org/t/p/w500${movie.poster_path}`}
                    alt={movie.title}
                  />
                </a>
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