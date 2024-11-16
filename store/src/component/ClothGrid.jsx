import React, { Component } from "react";
import ProductCard from "./ProductCard";

class ClothGrid extends Component {
  state = {
    products: [], // State to hold all products
    isLoading: true, // To handle loading state
    error: null, // To handle error state
  };

  async componentDidMount() {
    const query = `{
      products (type: "cloth"){
        id
        name
        price
        img_url
      }
    }`;

    try {
      const response = await fetch("http://localhost/Scandiweb/Controller/test.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ query }),
      });

      const result = await response.json();
      if (result.data && result.data.products) {
        this.setState({ products: result.data.products, isLoading: false });
      }
    } catch (error) {
      this.setState({ error: error.message, isLoading: false });
    }
  }

  render() {
    const { products, isLoading, error } = this.state;

    if (isLoading) {
      return <div>Loading products...</div>;
    }

    if (error) {
      return <div>Error: {error}</div>;
    }

    return (
      <div className="product-grid">
        {products.map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </div>
    );
  }
}

export default ClothGrid;
