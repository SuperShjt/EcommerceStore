import Navbar from "./component/Navbar";
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import AllProducts from './Pages/AllProducts';
import ClothProducts from './Pages/ClothProducts';
import TechProducts from './Pages/TechProducts';
import ProductPage from "./Pages/ProductPage";


function App() {
  

  return (
    <>
    <Router>
      <Navbar/>
      <Routes>
        <Route path="/" element={<AllProducts />} />
        <Route path="/cloth" element={<ClothProducts />} />
        <Route path="/tech" element={<TechProducts />} />
        <Route path="/product/:id" element={<ProductPage />} />
      </Routes>
    </Router>
     
    </>
  );
}

export default App
