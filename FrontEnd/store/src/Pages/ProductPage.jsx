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
      const response = await fetch("http://localhost/Scandiweb/Backend/Controller/test.php", {
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
    const { addToCart } = this.props;
  
    const errors = {};
    // Validate selected attributes
    product.attributes.forEach((attr) => {
      if (!selectedAttributes[attr.name]) {
        errors[attr.name] = true;
      }
    });
  
    if (Object.keys(errors).length > 0) {
      this.setState({ errors });
      alert("Please select all required attributes!");
      return;
    }
  
    const cartItem = {
      product_id: product.id,
      product_name: product.name,
      price: product.price,
      image: product.img_url[0],
      attributes: product.attributes.reduce((acc, attr) => {
        acc[attr.name] = attr.items.map((item) => ({
          valuex: item.valuex,
          display_value: item.display_value,
          selected: selectedAttributes[attr.name] === item.valuex, // Flag for selected to find selected attribute
        }));
        return acc;
      }, {}),
      quantity: 1,
    };
  
    addToCart(cartItem);
    alert("Item added to cart!");
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

          <div className="attributes">
                  {product.attributes.map((attr, attrIndex) => (
                    <div key={attrIndex} className="attribute" data-testid= {`product-attribute-${attr.name}`}>
                      <p><strong>{attr.name}: </strong></p>
                      <div className="attribute-items">
                        {attr.items.map((item, itemIndex) => (
                          <label
                          key={itemIndex}
                          className={`attribute-item ${
                            attr.name === "Color"
                            ? "color-item"
                            : "default-item"
                          } ${selectedAttributes[attr.name] === item.valuex ? "selected" : ""}`}
                          style={
                            attr.name === "Color"
                            ? { backgroundColor: item.valuex }
                            : {}
                          }
                          >
                            <input
                              type="radio"
                              name={attr.name}
                              value={item.valuex}
                              checked={selectedAttributes[attr.name] === item.valuex}
                              onChange={() => this.handleAttributeChange(attr.name, item.valuex)}
                              className="radio-input"
                              />
                            {attr.name !== "Color" && <span>{item.display_value}</span>}
                          </label>
                        ))}
                      </div>
                      {errors[attr.name] && <p style={{ color: "red" }}>This attribute is required!</p>}
                    </div>
                  ))}
                </div>

            <p><strong>Price: <br/> ${product.price.toFixed(2)} </strong></p>

          {product.inStock ? (
            <button data-testid='add-to-cart' className="product-add-button" onClick={this.handleAddToCart}>Add To Cart</button>
          ) : (
            <button data-testid='add-to-cart' disabled>Out Of Stock</button>
          )}
              <p data-testid='product-description'>
                 <strong>Description:</strong>
                  <span>{parse(product.description)}</span>
              </p>
        </section>
      </main>
    );
  }
}

export default (props) => <ProductPage {...props} id={useParams().id} />;