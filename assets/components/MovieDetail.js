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

  if (!movie) return <p>Chargement...</p>;

  return (
    <div>
      <h2>Titre : {movie.title}</h2>
      <h3>Titre original : {movie.original_title}</h3>
      <img src={`https://image.tmdb.org/t/p/w500${movie.poster_path}`} alt={movie.title} />
      <p>Description : {movie.overview}</p>
      <p>Date de sortie : {movie.release_date}</p>
    </div>
  );
}

export default MovieDetail;