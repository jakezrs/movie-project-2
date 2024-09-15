import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import TrendingMovies from './TrendingMovies';
import MovieDetail from './MovieDetail';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<TrendingMovies />} />
        <Route path="/movies/:id" element={<MovieDetail movieId={movieId} />} />
      </Routes>
    </Router>
  );
}

export default App;