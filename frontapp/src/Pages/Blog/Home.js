import React from "react";
import Article from "../../Components/Article";

const articles = [
    1,
    2,
    3,
    4,
    5
];

const Home = () => {
    return (
        <div>
            <h1>Hello world</h1>
            {articles.map((item) => <Article key={item} />)}
        </div>
    );
};

export default Home;