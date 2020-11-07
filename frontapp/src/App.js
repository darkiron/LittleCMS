import React from "react";
import './App.css';
import Home from "./Pages/Blog/Home";
import Article from "./Pages/Blog/Article";
import Page from "./Pages/Blog/Page";
import Menu from "./Components/Menu";

import {
    BrowserRouter as Router,
    Switch,
    Route,
} from "react-router-dom";

import Footer from "./Components/Footer";
import Header from "./Components/Header";

function App() {
  return (
    <Router>
        <Menu/>
        <Header/>
        <Switch>
            <Route path={"/article"}>
                <Article/>
            </Route>
            <Route path={"/page"}>
                <Page/>
            </Route>
            <Route path={"/"}>
                <Home/>
            </Route>
        </Switch>
        <Footer/>
    </Router>
  );
}

export default App;
