//import './bootstrap.js';
import './styles/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import TrendingMovies from './components/TrendingMovies';

// Render TrendingMovies
const trendingMoviesElement = document.getElementById('trending-movies');
if (trendingMoviesElement) {
  const trendingMoviesRoot = createRoot(trendingMoviesElement);
  trendingMoviesRoot.render(<TrendingMovies />);
}
