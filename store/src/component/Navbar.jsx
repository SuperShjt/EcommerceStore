import logo from '../assets/logo.png'
import cart from '../assets/cart.png'

function Navbar(){

    return(
        <navbar className="navbar">
            <ul className="sections">
                <li><a href="#">ALL</a></li>
                <li><a href="#">Cloth</a></li>
                <li><a href="#">Tech</a></li>
            </ul>
            <img src={logo} alt='Logo' className='img'/>
            <img src={cart} alt='Logo' className='img'/>
        </navbar>
    )
}
export default Navbar