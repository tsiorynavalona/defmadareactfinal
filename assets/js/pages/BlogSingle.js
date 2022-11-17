import React, { Component, Fragment } from 'react'

import axios from 'axios';
import { Link } from 'react-router-dom'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import CommentForm from './CommentForm';



 class BlogSingle extends Component {

    constructor(props) {
        super(props)

        this.state = {
            
           isloading : true, 
           blogposts : [],
           blogposts_latest : [],
           comments : [],
           categories : []
        }
      }
   
    
    

    callback = (messageSucess) => {
        // do something with value in parent component, like save to state
    
        let parentElement = document.querySelector('.container.content');
    
        let thelastChild = parentElement.lastChild;
        let messageSucessContainer = document.createElement("div");
        messageSucessContainer.classList.add('alert', 'alert-primary');
        messageSucessContainer.innerHTML = messageSucess;
        parentElement.insertAfter(messageSucessContainer, thelastChild);
        messageSucessContainer.scrollIntoView();
    }

    findBlogPost = () => { 
        axios.get(`../../api/blogpost/${this.props.id}`).then(
            blogposts => this.setState({blogposts : blogposts.data, isloading : false})
        )
    }
    findComments = () => { 
        axios.get(`../../api/blog/comments/${this.props.id}`).then(
            comments => this.setState({comments : comments.data, isloading : false})
        )
    }

    findBlogPostLatest = () => {
        axios.get(`../../api/blog/findlatest`).then(
            blogposts => this.setState({blogposts_latest : blogposts.data, isloading : false})
        )
    }

    findAllCategories = () => {
        axios.get(`../../api/blog/categories`).then(
            categorie => this.setState({categories : categorie.data, isloading : false})
        )
    }


    componentDidMount() {
        this.findBlogPostLatest();
        this.findBlogPost();
        this.findComments();
        this.findAllCategories()
        
    }

    refreshPage = () => {
        
        this.setState({
            blogposts : [],
            blogposts_latest : [],
            comments : [],
            isloading : true});

        this.findBlogPostLatest();
        this.findBlogPost();
        this.findComments();
    }

    
   
    
    render() {
        const getComment = () => {
            if(this.state.comments.length > 0) {
                
                return this.state.comments.map( (comment) => {
                    return (
                        <Fragment key={comment.id}>
                            <strong>{comment.name}</strong>
                            <span>{new Intl.DateTimeFormat('fr-FR', {year: 'numeric', month: '2-digit',day: '2-digit'}).format(comment.createdAt.timestamp + "999")}</span>
                            <p>{comment.message}</p>
                            <hr />
                        </Fragment>
                    
                    )
                    })
                
            } else {
                return <span>Aucun commentaire pour le moment</span>
            }
        }
            
        // Init with default setup
        
        return (
            <div className='container content'>
                {this.state.isloading === true ? (
                               
                               <div className='fa-3x row'>
                                       <FontAwesomeIcon icon="spinner" pulse style={{ margin : '30px auto', color : 'green' }} />
                               </div>
                       ) : (
                           <div className='row'  style={{ margin : '50px auto'}}>
                           {this.state.blogposts.map(blogpost => { return (
                               <>
                               <div className='col-md-8' key={blogpost}>
                                   <article>
                                   <h4>{blogpost.title}</h4>
                                   <img src={require(`../../images/${blogpost.image.url}`)} style={{ maxWidth : '375px'}}/>
                                   <p>{blogpost.description}</p>
                                   {
                                       blogpost.categories.map(categorie => <p><Link key={categorie.id} to={`../categorie/${categorie.name}`}>{categorie.name}</Link></p>)

                                   }
                                   <p>publié le {new Intl.DateTimeFormat('fr-FR', {year: 'numeric', month: '2-digit',day: '2-digit'}).format(blogpost.createdAt.timestamp + "999")}</p>
                                   </article>
                                   <div className='comments'>
                                   <h5>Commentaires</h5>
                                   
                                     {getComment()}
                                   <h5>Laissez un commentaires</h5>
                                   <CommentForm postId={blogpost.id} parentCallback={this.callback}></CommentForm>
                                   </div>

                               </div>
                               <div className='col-md-4'>
                                   <h5>Les dernières articles</h5>
                                   { this.state.blogposts_latest.map(blogpost => {
                                       return <p><Link onClick={this.refreshPage} key={blogpost.id} to={`../../blog/post/${blogpost.id}`}>{blogpost.title}</Link></p>
                                   }) }
                                   <h5>Categories</h5>
                                   { this.state.categories.map(categorie => {
                                       return <p><Link key={categorie.id} to={`../categorie/${categorie.name}`}>{categorie.name}</Link></p>
                                   })}

                                  
                               </div>
                               </>
                           )
                                        

                           })}
                           
                       </div>

                       ) }
                
            </div>
        )
    }
}

export default BlogSingle;
