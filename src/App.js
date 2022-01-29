import React from 'react'
import logo from './logo.svg';
import './App.css';
import history from './component/history'
import {BrowserRouter, Route, Switch,Router} from "react-router-dom";
import Blog from './Pages/Blog'


function App() {
  return (
      <BrowserRouter>
        <Router history={history}>
          <Switch>
            <Route path={"/"} component={Blog}/>
          </Switch>
        </Router>
      </BrowserRouter>
  );
}

export default App;
