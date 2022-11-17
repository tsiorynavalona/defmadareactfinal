import React, { Component } from 'react'
import axios from 'axios';
import { DoleanceForm } from './DoleanceForm';
import moment from 'moment';

class Doleonce extends Component {
    callback = (messageSucess) => {
        // do something with value in parent component, like save to state
    
        let parentElement = document.querySelector('.container.content');
        console.log(parentElement);
        let theFirstChild = parentElement.firstChild;
        let messageSucessContainer = document.createElement("div");
        messageSucessContainer.classList.add('alert', 'alert-primary');
        messageSucessContainer.innerHTML = messageSucess;
        parentElement.insertBefore(messageSucessContainer, theFirstChild);
        messageSucessContainer.scrollIntoView();
    }

    constructor(props) {
        super(props);
        this.state = {
            
            subject: '',
            description: '',
            email: '',
            phone: '',
            doleances: [], 
            loading: true
          };
        //   this.handleChange = this.handleChange.bind(this);
        //   this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount() {
        this.getDoleances();
        
    }

    getDoleances = () => {
        axios.get('https://localhost:8000/api/doleance').then(doleances => {
            this.setState({ doleances: doleances.data, loading: false })
        })
    }
        
    render() {
       
        const loading = this.state.loading;
        return (
          <div className='container content'>
              <div className='doleance-content doleance-head'>
                  <p>
                    Vous pouvez nous envoyer vos doléance. L'envoie des doléance est faite pour le public mais chaque doléance reçue doit être modérée
                  </p>
                  <a href="#doleance-form" className="btn btn-success">Envoyer doléance</a>
              </div>
            
           <div className="doleance-content doleance-list">
              <h4 className='doleance-title'>Les doléances reçues :</h4>
              <div className="doleance-post">
              {loading ? (
                            <div className={'row text-center'}>
                                <span>
                                    chargement..
                                </span>
                            </div>
    
                        ) : (<div>{this.state.doleances.map(doleance =>  
                            <div className='doleance-post' key={doleance.id}>
                                <h5>{doleance.subject}</h5>
                                <hr/>
                                {doleance.description}<br/>
                                
                                publié le {new Intl.DateTimeFormat('fr-FR', {year: 'numeric', month: '2-digit',day: '2-digit'}).format(doleance.createdAt.timestamp + "999")} par {doleance.email}
                                {/* publié le {moment(doleance.createdAt.timestamp).format('L')} par {doleance.email} */}
                            </div>
                        )}</div>)            
        
                }
              </div>
            </div>
            <div id="doleance-form" className="doleance-content">
                <h4 className='doleance-title'>Formulaire de doléance :</h4>
                <DoleanceForm parentCallback={this.callback}></DoleanceForm>
            </div>
            
          </div>
        )
    }
}

export default Doleonce;
