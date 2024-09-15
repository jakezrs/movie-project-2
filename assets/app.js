import React from 'react';
import { createRoot } from 'react-dom/client';
import TrendingMovies from './components/TrendingMovies';
import MovieDetail from './components/MovieDetail';

import './styles/app.css';

// Render TrendingMovies
const trendingMoviesElement = document.getElementById('trending-movies');
if (trendingMoviesElement) {
  const trendingMoviesRoot = createRoot(trendingMoviesElement);
  trendingMoviesRoot.render(<TrendingMovies />);
}

// Render MovieDetail
const movieDetailElement = document.getElementById('movie-detail');
if (movieDetailElement) {
  const movieDetailRoot = createRoot(movieDetailElement);
  const movieId = movieDetailElement.getAttribute('data-movie-id');
  movieDetailRoot.render(<MovieDetail movieId={movieId} />);
}