import React, { Component } from 'react';
import Front from '../pages/Front';
import axios from 'axios';
import DirectionReveal from 'direction-reveal';
import { Link } from 'react-router-dom';
import Helmet from 'react-helmet';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

 class Accueil extends Component {
    constructor(props) {
      super(props)
    
      this.state = {
         isloading : true, 
         blogposts : []
      }
    }
    componentDidMount() {
        this.findBlogPost();
       
    }

    findBlogPost = () => {
        axios.get('api/blogpost-home').then(
            blogposts => this.setState({blogposts : blogposts.data, isloading : false})
        )
    }

    // Init with default setup


    render() {
        const directionRevealDemo = DirectionReveal();

// Init with all options at default setting
        const directionRevealDefault = DirectionReveal({
            selector: '.direction-reveal',
            itemSelector: '.direction-reveal__card',
            animationName: 'swing',
            animationPostfixEnter: 'enter',
            animationPostfixLeave: 'leave',
            enableTouch: true,
            touchThreshold: 250
        });

       

        return (
            <>
                    
                <header className="masthead">
                    <div className="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                        <div className="d-flex justify-content-center">
                            <div className="text-center">
                                <h2 className="mx-auto my-0 text-uppercase">Déforestation mada</h2>
                                <p className="text-white-50 mx-auto mt-2 mb-5">A free, responsive, one page Bootstrap theme created by Start Bootstrap.</p>
                    
                            </div>
                        </div>
                    </div>
                </header>
                <div className='container content'>
                    <div className="info">
                        <h4 align="center" className="home-title">Les forêts de Madagascar sont reconnues pour la diversité de leur faune et de leur flore uniques :
                                                                                                            l'île abrite 5% des espèces du monde.</h4>
                        <p className="text-black-50 mb-0">Madagascar est classé parmi les « hot spot » de la biodiversité mondiale. La variété des climats, conjuguée à celle des reliefs, a favorisé le développement d’une faune et d’une flore uniques au monde. La biodiversité de Madagascar est aujourd’hui largement menacée par les activités anthropiques, notamment la déforestation, et les ressources exceptionnelles de l’Ile attisent les convoitises (secteur minier,
                                                pierres et minerais précieux, bois précieux, etc.)</p>


                    </div>
                    <div className="doleance-home">
                        <h4 className="home-title">Nous pouvons recevoir vos doléances</h4>
                        <div className="row">
                            <div className="col-sm-6 img-container">
                                {/* <img src="./images/demo-image-01.jpg" /> */}
                                <img src={require('../../images/demo-image-01.jpg')} alt="image"/>
                            </div>
                            <div className="col-md-6">
                                <p className="text-black-50 mb-0">Vestibulum congue, quam nec tempor rhoncus, metus sapien fringilla metus, ut molestie orci augue ut lectus. Pellentesque ut finibus nibh. Nulla facilisi. Suspendisse orci nibh, venenatis id purus id, efficitur consequat neque. Maecenas neque enim, dignissim placerat hendrerit ac, consectetur sed nunc. Suspendisse auctor augue metus, vel finibus nisi gravida et. Nullam bibendum risus id sem viverra, eget bibendum leo ultrices. Praesent porttitor metus eget velit males</p>
                            </div>
                        </div>
                        
                    </div>
                    <div className="blog-home">
                        <h4 className="home-title">Blog</h4>
                        <p className="text-black-50 mb-0">Vestibulum congue, quam nec tempor rhoncus, metus sapien fringilla metus, ut molestie orci augue ut lectus. Pellentesque ut finibus nibh. Nulla facilisi. Suspendisse orci nibh, venenatis id purus id, efficitur consequat neque. Maecenas neque enim, dignissim placerat hendrerit ac, consectetur sed nunc. Suspendisse auctor augue metus, vel finibus nisi gravida et. Nullam bibendum risus id sem viverra, eget bibendum leo ultrices. Praesent porttitor metus eget velit males</p>
                        <div className='blogposts-home'>
                            {this.state.isloading === true ? (
                               
                                    <div className='fa-3x row'>
                                
                                            <FontAwesomeIcon icon="spinner" pulse style={{ margin : '30px auto', color : 'green' }} />
                                    </div>   
                                
                            ) : (
                                <div className='row'  style={{ margin : '50px auto'}}>
                                {this.state.blogposts.map(blogpost => { return (
                                    <div className='col-md-4'>
                                        <div className="direction-reveal" key={blogpost.id} style={{ textAlign : 'center' }}>
                                            <div className="direction-reveal__card">
                                                <img src={require(`../../images/${blogpost.image.url}`)} style={{ width : '400px' , height : '250px'}} className="direction-reveal__img"/>

                                                <div className="direction-reveal__overlay">
                                                    <h5 className="direction-reveal__title">{blogpost.title}</h5>
                                                    <p className="direction-reveal__text" style={{ fontSize : '11px', marginTop : '20px' }}>{blogpost.description.substring(0, 25)} ...</p>
                                                    <Link to={`blog/post/${blogpost.id}`} className='btn btn-success' style={{ margin : '40px auto'}} >Lire la suite</Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )
                                             
                                })}
                                <Link className="btn btn-success" to="/blog" style={{ maxWidth : '300px', margin : '30px auto'}}>Voir plus d'article</Link>
                            </div>

                            ) }
                        
                        </div>

                    </div>
                </div>
                
            </>
            
        )
    }
}

export default Accueil;
