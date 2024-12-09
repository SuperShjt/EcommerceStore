import React, { Component } from "react";
import ProductGrid from "../component/ProductGrid";

class AllProducts extends Component {
  render() {
    const { addToCart, toggleCart } = this.props; 
    return (
      <main className="page-layout">
        <h1><strong>Products</strong></h1>
        <ProductGrid addToCart={addToCart}  toggleCart={toggleCart} /> 
      </main>
    );
  }
}

export default AllProducts;
