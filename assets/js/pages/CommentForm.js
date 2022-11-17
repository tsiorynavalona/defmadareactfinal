import React, {useState} from 'react';
import { useForm } from "react-hook-form";
import axios from 'axios';

export default function CommentForm(props) {

  const [messageSucess, messageError] = useState();
  const { register, handleSubmit, watch, formState: { errors }, getValues } = useForm();
    
  const onSubmit = data => 
      axios.post('../api/post_comment', {
        nom : data.nom,
        message : data.message,
        email : data.email,
        post_id : props.postId
        
      }, 
       ).then((res) => { 
           props.parentCallback(res.data)
        })
       .catch((e) => { 
           console.log(e);
        //   parentCallback(res.data)
     })
  ;
    

  return (
    <>
        
           <form onSubmit={handleSubmit(onSubmit)}>
               <div className='form-group'>
                   <label htmlfor='nom'>Votre nom</label>
                   <input {...register("nom" , { required: true })} className='form-control' id="nom"/>
                   {errors.nom && <span>Ce champ est requis</span>}
               </div>
               <div className='form-group'>
                   <label htmlfor='email'>Votre mail</label>
                   <input {...register("email" , { required: true, 
                                                   pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ })} 
                                                   className='form-control' id='email' />
                 
                   {errors.email && errors.email.type === "pattern" && <span>Entrez un email valide</span> }
                   
               </div>
               
               
               <div className='form-group'>
                   <label htmlfor='message'>Message</label>
                   <textarea {...register("message" , { required: true })} className='form-control' id="message"/>
                   {errors.message && <span>This field is required</span>}
               </div>
               
              
               <div className='form-group'>
            
                
                
                <input type="submit" className='btn btn-success' />
                </div>
            </form>
        
    
    
    </>
  );
}
