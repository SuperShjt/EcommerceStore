import React,{Component} from "react";
import TechGrid from "../component/TechGrid";

class TechProducts extends Component{

    render(){
        
        return(
            <main className="page-layout">
            
            <h1><strong>Tech Products</strong></h1>
            <TechGrid></TechGrid>
            </main>
            


        );
        
    }



}
export default TechProducts;