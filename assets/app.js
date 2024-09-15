//import './bootstrap.js';
import './styles/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';

const App = () => {
    return (
        <div>
            <h1>Bienvenue sur React 18 dans Symfony 7</h1>
        </div>
    );
};

const root = createRoot(document.getElementById('root'));
root.render(<App />);
