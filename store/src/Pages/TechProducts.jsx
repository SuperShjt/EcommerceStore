import React,{Component} from "react";
import TechGrid from "../component/TechGrid";

class TechProducts extends Component{

    render(){
        const { addToCart } = this.props; 
        return(
            <main className="page-layout">
            
            <h1><strong>Tech Products</strong></h1>
            <TechGrid addToCart={addToCart}></TechGrid>
            </main>
            


        );
        
    }



}
export default TechProducts;