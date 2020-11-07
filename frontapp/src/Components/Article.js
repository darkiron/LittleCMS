import React from "react";
import Toudou from "./Toudou";
import { Link } from "react-router-dom";

const Article = ({key}) => {
    return (<aticle><Toudou/><Link to={`/article/article-${key}`}>Lire plus</Link></aticle>);
}

export default Article;