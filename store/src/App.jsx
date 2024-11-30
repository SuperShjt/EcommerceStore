import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Navbar from "./component/Navbar";
import AllProducts from "./Pages/AllProducts";
import ClothProducts from "./Pages/ClothProducts";
import TechProducts from "./Pages/TechProducts";
import ProductPage from "./Pages/ProductPage";

function App() {
  const [cartItems, setCartItems] = React.useState([]);

  const addToCart = (item) => {
    setCartItems((prevItems) => [...prevItems, item]);
  };

  const clearCart = () => {
    setCartItems([]);
  };

  return (
    <>
      <Router>
        <Navbar cartItems={cartItems} clearCart={clearCart} />
        <Routes>
          <Route path="/" element={<AllProducts addToCart={addToCart} />} /> {/* Pass addToCart */}
          <Route path="/cloth" element={<ClothProducts addToCart={addToCart}/>} />
          <Route path="/tech" element={<TechProducts addToCart={addToCart}/>} />
          <Route path="/product/:id" element={<ProductPage addToCart={addToCart} />} />
        </Routes>
      </Router>
    </>
  );
}

export default App;
