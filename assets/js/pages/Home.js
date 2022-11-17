import React, {Component} from 'react';
import {Route, Switch,Redirect, Link, withRouter} from 'react-router-dom';
// import Users from './Users';
// import Posts from './Posts';
import Accueil from '../pages/Accueil';   
import Doleonce from '../pages/Doleonce';  
import Bianco from '../pages/Bianco'; 
import Stat from '../pages/Stat'; 
import Contact from '../pages/Contact'; 
import Blog from '../pages/Blog'; 
import BlogSingle from './BlogSingle';
import Categorie from './Categorie';
import ScrollToTop from './ScrollToTop';
import LoadingBar from 'react-top-loading-bar'


class Home extends Component {

    
    constructor(props) {
      super(props)
    
      this.state = {
         progress : 0
      }
    }

    componentDidUpdate(prevProps) {
        if (this.props.location !== prevProps.location) {
          this.onRouteChanged();
        }
      }
    

    componentDidMount() {
       // this.setState({progess : computedProgress})
       this.setState({progress : 100})
    }
    
    onRouteChanged = () => {
     console.log('ROUTE CHANGED');
    
    }
    
    render() {
        return (
           <div>      
               <div>
               <LoadingBar color='#f11946' progress={this.state.progress} onLoaderFinished={() => this.setState({progress : 0})} />
               </div>
                <br />      
                        <nav className="navbar navbar-expand-lg navbar-light fixed-top navbar-shrink" id="mainNav">
                            <div className="container px-4 px-lg-5">
                                 <Link className={"navbar-brand"} to={"/"}> Deforestation Mada </Link>
                                <div className="collapse navbar-collapse" id="navbarResponsive">
                                    <ul className="navbar-nav ms-auto">
                                        <li className="nav-item">
                                            {/* <a class="nav-link" href={{ path('home') }}>Accueil</a> */}
                                            <Link className={"nav-link"} to={"/accueil"}> Accueil </Link>
                                        </li>
                                        <li className="nav-item">
                                        <Link className={"nav-link"}  to={"/doleance"}>Doléances </Link>
                                        </li>
                                        <li className="nav-item">
                                        <Link className={"nav-link"}  to={"/blog"}>Blog </Link>
                                        </li>
                                        <li className="nav-item">
                                        <Link className={"nav-link"} to={"/bianco"}> Bianco </Link>
                                        </li>
                                        <li className="nav-item">
                                        <Link className={"nav-link"} to={"/stat"}> Stat </Link>
                                        </li>
                                        <li className="nav-item">
                                        <Link className={"nav-link"} to={"/contact"} > Contact </Link>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        
                        <ScrollToTop>
                            <Switch>
                                <Redirect exact from="/" to="/accueil" />
                                <Route path="/accueil" component={Accueil} />                           
                                <Route path="/doleance" component={Doleonce} />
                                
                                    <Route path="/blog"
                                        render={({ match: { url } }) => (
                                            <>
                                            <Route path={`${url}/`} component={Blog} exact />
                                            <Route path={`${url}/post/:id`} render={(props) => <BlogSingle id={props.match.params.id} {...props}/>} />
                                            <Route path={`${url}/categorie/:nom_categorie`} render={(props) => <Categorie nom={props.match.params.nom_categorie} {...props}/>} /> 
                                            </>
                                        )}
                                    />
                                
        
                                <Route path="/bianco" component={Bianco} />
                                <Route path="/stat" component={Stat} />
                                <Route path="/contact" component={Contact} />
                                
                                
                            </Switch> 
                        </ScrollToTop> 
                                                     
                                    
                                   
                                    
                        
                    </div>
        )
    }
}
    
export default Home;