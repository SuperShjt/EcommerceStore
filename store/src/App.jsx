import React from "react";
import Navbar from "./component/Navbar";
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import AllProducts from './Pages/AllProducts';
import ClothProducts from './Pages/ClothProducts';
import TechProducts from './Pages/TechProducts';
import ProductPage from "./Pages/ProductPage";

function App() {
  const [cartItems, setCartItems] = React.useState([]);

  // Function to add an item to the cart
  const addToCart = (item) => {
    setCartItems((prevItems) => [...prevItems, item]);
  };

  // Function to clear the cart
  const clearCart = () => {
    setCartItems([]); // Reset cartItems to an empty array
  };

  return (
    <>
      <Router>
        <Navbar cartItems={cartItems} clearCart={clearCart} /> {/* Pass cartItems to Navbar */}
        <Routes>
          <Route path="/" element={<AllProducts />} />
          <Route path="/cloth" element={<ClothProducts />} />
          <Route path="/tech" element={<TechProducts />} />
          <Route path="/product/:id" element={<ProductPage addToCart={addToCart}  />} />
        </Routes>
      </Router>
    </>
  );
}

export default App;
