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
    const { addToCart } = this.props;
    const {product} = this.state;
    const attributes = product.attributes || [];
    
    const selectedAttributes = attributes.reduce((acc, attr) => {
      acc[attr.name] = attr.items[0]?.valuex || null; 
      return acc;
    }, {});
  
    const allAttributes = attributes.reduce((acc, attr) => {
      acc[attr.name] = attr.items;
      return acc;
    }, {});
  
    const cartItem = {
      product_id: product.id,
      product_name: product.name,
      price: product.price,
      image: product.img_url[0],
      attributes: selectedAttributes,
      allAttributes: allAttributes,
      quantity: 1,
    };
  
    // Add to cart
    addToCart(cartItem);
    alert(
      `Added ${product.name} to the cart with attributes: ${JSON.stringify(
        selectedAttributes
      )} and all attributes: ${JSON.stringify(attributes)}`
    );
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
              <div key={attrIndex} className="attribute">
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
            <button className="product-add-button" onClick={this.handleAddToCart}>Add To Cart</button>
          ) : (
            <button className="product-add-button" disabled>Out Of Stock</button>
          )}
              <p>
                 <strong>Description:</strong>
                  <span>{parse(product.description)}</span>
              </p>
        </section>
      </main>
    );
  }
}

export default (props) => <ProductPage {...props} id={useParams().id} />;
