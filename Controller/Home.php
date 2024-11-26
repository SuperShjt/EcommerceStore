<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphQL Product Query</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .add-order {
            background-color: #007bff;
        }
        .add-order:hover {
            background-color: #0056b3;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ccc;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>

<h1>Product Query</h1>
<button id="fetchProducts">Fetch Products</button>

<h2>Response:</h2>
<div id="response"></div>

<script>
document.getElementById('fetchProducts').addEventListener('click', async () => {
    const query = `
      {
        fullproduct(id: "jacket-canada-goosee") {
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
        const response = await fetch('http://localhost/Scandiweb/Controller/test.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ query })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        if (data.errors) {
            document.getElementById('response').textContent = `Error: ${JSON.stringify(data.errors, null, 2)}`;
        } else {
            displayProduct(data.data.fullproduct);
        }
    } catch (error) {
        document.getElementById('response').textContent = `Error: ${error.message}`;
    }
});

function displayProduct(product) {
    const responseDiv = document.getElementById('response');
    responseDiv.innerHTML = ''; // Clear previous response

    const productDetails = document.createElement('div');
    productDetails.innerHTML = `
        <strong>Product ID:</strong> ${product.id}<br>
        <strong>Name:</strong> ${product.name}<br>
        <strong>Brand:</strong> ${product.brand}<br>
        <strong>In Stock:</strong> ${product.inStock}<br>
        <strong>Description:</strong> ${product.description}<br>
        <strong>Category:</strong> ${product.category}<br>
        <strong>Price:</strong> ${product.price}<br>
        <strong>Images:</strong> ${product.img_url.join(', ')}<br>
        <strong>Attributes:</strong> ${product.attributes.map(attr => 
            `${attr.name}: ${attr.items.map(item => `${item.display_value} (${item.valuex})`).join(', ')}` 
        ).join('<br>')}<br><br>
        <button class="add-order">Add to Orders</button>
    `;

    const addOrderButton = productDetails.querySelector('.add-order');
    addOrderButton.addEventListener('click', () => addToOrders(product));

    responseDiv.appendChild(productDetails);
}

async function addToOrders(product) {
    const mutation = `
    mutation {
        createOrder(
            product_id: "${product.id}",
            price: ${product.price},
            attributes: """${JSON.stringify(product.attributes)}"""
        ) 
    }
`;

    try {
        const response = await fetch('http://localhost/Scandiweb/Controller/test.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ query: mutation })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        if (data.errors) {
            alert(`Error: ${JSON.stringify(data.errors, null, 2)}`);
        } else {
            alert(data.data.createOrder); // Show success message
        }
    } catch (error) {
        alert(`Error: ${error.message}`);
    }
}
</script>

</body>
</html>
