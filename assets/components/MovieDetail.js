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
      <img src={`https://image.tmdb.org/t/p/w300${movie.poster_path}`} alt={movie.title} />
      <h4>Description : {movie.overview}</h4>
      <h4>Date de sortie : {movie.release_date}</h4>
    </div>
  );
}

export default MovieDetail;