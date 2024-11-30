import React, { Component } from "react";
import ProductGrid from "../component/ProductGrid";

class AllProducts extends Component {
  render() {
    const { addToCart } = this.props; // Receive from parent
    return (
      <main className="page-layout">
        <h1><strong>Products</strong></h1>
        <ProductGrid addToCart={addToCart} /> {/* Pass to ProductGrid */}
      </main>
    );
  }
}

export default AllProducts;
