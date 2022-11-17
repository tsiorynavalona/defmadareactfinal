import React, { Component } from 'react'
import DirectionReveal from 'direction-reveal';
import axios from 'axios';
import { Route, Link } from 'react-router-dom'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import BlogSingle from './BlogSingle';
import ReactPaginate from 'react-paginate';


 class Categorie extends Component {

    constructor(props) {
        super(props)
      
        this.state = {
           isloading : true, 
           blogposts : [],
           currentPage : 0
        }
      }

    findBlogPost = () => {
        axios.get(`../../api/blog/categorie/${this.props.nom}`).then(
            blogposts => this.setState({blogposts : blogposts.data, isloading : false})
        )
    }
    componentWillUnmount() {
        
    }
    componentDidMount() {
        this.findBlogPost()
    }

    handlePageClick = ({ selected: selectedPage }) => {
        
        this.setState({currentPage : selectedPage})
        window.scrollTo(0,0)
    }
    
    render() {
        const PER_PAGE = 6;
        const offset = this.state.currentPage * PER_PAGE;

        const currentPageData = this.state.blogposts
            .slice(offset, offset + PER_PAGE)
            .map(blogpost => { return (
                <div className='col-md-4'>
                    <div className="direction-reveal" key={blogpost.id} style={{ textAlign : 'center' }}>

                        <div className="direction-reveal__card">
                            <img src={require(`../../images/${blogpost.image.url}`)} style={{ width : '400px' , height : '250px'}} className="direction-reveal__img"/>
                            
                            <div className="direction-reveal__overlay">
                                 <h5 className="direction-reveal__title">{blogpost.title}</h5>
                                 <p className="direction-reveal__text" style={{ fontSize : '12px', marginTop : '20px' }}>{blogpost.description.substring(0, 45)} ...</p>
                                 <Link className='btn btn-success' style={{ margin : '40px auto'}} to={`../post/${blogpost.id}`}>Lire la suite</Link>
                                 
                             </div>
                            </div>
                            


                    </div>
                </div>
            )
                         

            });
        const pageCount = Math.ceil(this.state.blogposts.length / PER_PAGE);
       
        // Init with default setup
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
            <div className='container content'>
                {this.state.isloading === true ? (
                               
                               <div className='fa-3x row'>
                           
                                       <FontAwesomeIcon icon="spinner" pulse style={{ margin : '30px auto', color : 'green' }} />
                               </div>
                          
                               
                       ) : (
                           <div className='row'  style={{ margin : '50px auto'}}>
                           {currentPageData}
                           {pageCount > 1 && (
                               <nav aria-label="Page navigation">
                               <ReactPaginate
                                       previousLabel={"← Précédent"}
                                       nextLabel={"Suivant →"}
                                       pageCount={pageCount}
                                       onPageChange={this.handlePageClick}
                                       containerClassName={"pagination"}
                                       breakClassName={'page-item'}
                                       breakLinkClassName={'page-link'}
                                       containerClassName={'pagination'}
                                       pageClassName={'page-item'}
                                       pageLinkClassName={'page-link'}
                                       previousClassName={'page-item'}
                                       previousLinkClassName={'page-link'}
                                       nextClassName={'page-item'}
                                       nextLinkClassName={'page-link'}
                                       activeClassName={'active'}
                                      
                                   />
                           </nav>
                           )}
                           
                           
                       </div>

                       ) }
            
            </div>
        )
    }
}

export default Categorie;
