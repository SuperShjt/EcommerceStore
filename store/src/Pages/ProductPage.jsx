import React, { Component } from "react";
import { useParams } from "react-router-dom";
import parse from "html-react-parser";

class ProductPage extends Component {
  state = {
    product: null,
    loading: true,
    error: null,
    selectedAttributes: {}, // Store user-selected attributes
    errors: {}, // Track if any attribute is not selected
  };

  async componentDidMount() {
    const { id } = this.props; // Get product ID from URL props
    const query = `
      {
        fullproduct(id: "${id}") {
          id
          name
          brand
          description
          inStock
          category
          price
          img_url
          attributes {
            name
            items {
              display_value
              valuex
            }
          }
        }
      }
    `;

    try {
      const response = await fetch("http://localhost/Scandiweb/Controller/test.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ query }),
      });
      const result = await response.json();

      if (result.errors) {
        this.setState({ error: result.errors[0].message, loading: false });
      } else {
        this.setState({ product: result.data.fullproduct, loading: false });
      }
    } catch (error) {
      this.setState({ error: error.message, loading: false });
    }
  }

  handleAttributeChange = (attributeName, value) => {
    this.setState((prevState) => ({
      selectedAttributes: {
        ...prevState.selectedAttributes,
        [attributeName]: value,
      },
      errors: { ...prevState.errors, [attributeName]: false }, // Clear error for that attribute
    }));
  };

  handleAddToCart = () => {
    const { product, selectedAttributes } = this.state;
    const { addToCart } = this.props; // Access addToCart passed from App

    const errors = {};
    // Check if all attributes have been selected
    product.attributes.forEach((attr) => {
      if (!selectedAttributes[attr.name]) {
        errors[attr.name] = true; // Mark as not selected
      }
    });

    if (Object.keys(errors).length > 0) {
      this.setState({ errors });
      alert("Please select all required attributes!");
    } else {
      const cartItem = {
        product_id: product.id,
        price: product.price,
        image: product.img_url[0],
        attributes: selectedAttributes,
      };
      addToCart(cartItem); // Call the passed-in addToCart function
      alert("Item added to cart!");
    }
  };

  render() {
    const { product, loading, error, selectedAttributes, errors } = this.state;

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error: {error}</p>;

    return (
      <main className="product">
        <ul className="product-gallery" data-testid="product-gallery">
          {product.img_url.map((url, index) => (
            <li key={index}>
              <img src={url} alt={product.name} style={{ width: "200px" }} />
            </li>
          ))}
        </ul>

        <img src={product.img_url[0]} alt="" className="product-current-image" />

        <section className="product-details">
          <h1>{product.name}</h1>
          <p><strong>Brand:</strong> {product.brand}</p>
          <p>
             <strong>Description:</strong>
              <span>{parse(product.description)}</span>
          </p>
          <p><strong>Price:</strong> ${product.price.toFixed(2)}</p>
          <p><strong>In Stock:</strong> {product.inStock ? "Yes" : "No"}</p>

          <div className="attributes">
            <strong>Attributes:</strong>
            {product.attributes.map((attr, attrIndex) => (
              <div key={attrIndex} className="attribute">
                <p>{attr.name}:</p>
                <div className="attribute-items">
                  {attr.items.map((item, itemIndex) => (
                    <label key={itemIndex}>
                      <input
                        type="radio"
                        name={attr.name}
                        value={item.valuex}
                        checked={selectedAttributes[attr.name] === item.valuex}
                        onChange={() => this.handleAttributeChange(attr.name, item.valuex)}
                      />
                      {item.display_value}
                    </label>
                  ))}
                </div>
                {errors[attr.name] && <p style={{ color: "red" }}>This attribute is required!</p>}
              </div>
            ))}
          </div>

          {product.inStock ? (
            <button onClick={this.handleAddToCart}>Add To Cart</button>
          ) : (
            <button disabled>Out Of Stock</button>
          )}
        </section>
      </main>
    );
  }
}

export default (props) => <ProductPage {...props} id={useParams().id} />;
