import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Navbar from "./component/Navbar";
import AllProducts from "./Pages/AllProducts";
import ClothProducts from "./Pages/ClothProducts";
import TechProducts from "./Pages/TechProducts";
import ProductPage from "./Pages/ProductPage";
import GreyScreen from "./component/GreyScreen";

function App() {
  const [cartItems, setCartItems] = React.useState([]);
  const [cartStatus, setCartStatus] = React.useState("closed"); // New state for cartStatus

  const addToCart = (newItem) => {
    setCartItems((prevItems) => {
      const existingItemIndex = prevItems.findIndex(
        (item) =>
          item.product_id === newItem.product_id &&
          JSON.stringify(item.attributes) === JSON.stringify(newItem.attributes)
      );

      if (existingItemIndex !== -1) {
        const updatedItems = [...prevItems];
        updatedItems[existingItemIndex].quantity += newItem.quantity;
        return updatedItems;
      }

      return [...prevItems, { ...newItem, quantity: 1 }];
    });
  };

  const clearCart = () => {
    setCartItems([]);
  };

  const updateCartItems = (callback) => {
    setCartItems((prevItems) => {
      const updatedItems = callback(prevItems);
      console.log("Updated Cart Items:", updatedItems);
      return updatedItems;
    });
  };

  const toggleCart = () => {
    setCartStatus((prevStatus) => (prevStatus === "closed" ? "open" : "closed"));
  };

  return (
    <>
      <Router>
        <Navbar
          cartItems={cartItems}
          clearCart={clearCart}
          updateCartItems={updateCartItems}
          cartStatus={cartStatus}
          toggleCart={toggleCart} // Pass toggleCart function
        />
        <GreyScreen cartStatus={cartStatus}> {/* Pass cartStatus to GreyScreen */}
          <Routes>
            <Route path="/" element={<AllProducts addToCart={addToCart} />} />
            <Route path="/cloth" element={<ClothProducts addToCart={addToCart} />} />
            <Route path="/tech" element={<TechProducts addToCart={addToCart} />} />
            <Route path="/product/:id" element={<ProductPage addToCart={addToCart} />} />
          </Routes>
        </GreyScreen>
      </Router>
    </>
  );
}

export default App;
