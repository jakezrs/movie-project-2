import React, { useState, useEffect } from 'react';

function MovieDetail({ movieId }) {
  const [movie, setMovie] = useState(null);

  useEffect(() => {
    const fetchMovie = async () => {
      const response = await fetch(`/api/movies/${movieId}`);
      const data = await response.json();
      setMovie(data);
    };

    fetchMovie();
  }, [movieId]);

  if (!movie) return <p>Loading movie details...</p>;

  return (
    <div>
      <h2>{movie.title}</h2>
      <img src={`https://image.tmdb.org/t/p/w500${movie.poster_path}`} alt={movie.title} />
      <p>{movie.overview}</p>
      <p>Release date: {movie.release_date}</p>
    </div>
  );
}

export default MovieDetail;