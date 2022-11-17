import React, { Component } from 'react'
import ContactForm from './ContactForm';



// let style = '<style>
// input[type="submit"] {
//     margin: 20px auto;
// }

// .contact-grid {
//     padding: 15px 20px;
// }

// .contact-form {
//     background: #00800047;
// }
// </style>'; 
 class Contact extends Component {

    constructor(props) {
        super(props);
        this.state = {
            
           
          };
        //   this.handleChange = this.handleChange.bind(this);
        //   this.handleSubmit = this.handleSubmit.bind(this);
    }

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
    
    render() {
        return (
 
            <div className='container content'>
    
                <div className="row">
                    <div className="col-md-6 contact-grid">
                        <h3>Nos contacts</h3>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia fugiat iusto eligendi voluptatibus, officia aliquam temporibus commodi laborum! Quisquam ullam tenetur enim debitis recusandae dolores magnam atque cum non incidunt!

                    </div>
                    <div className="col-md-6 contact-grid contact-form" style={{  backgroundColor: "#00800047", padding: "25px"   }} >
                        <h3>Votre message :</h3>
                        <ContactForm parentCallback={this.callback}></ContactForm>
                       
                    </div>
                </div>
                
            </div>
        )
    }
}

export default Contact;
