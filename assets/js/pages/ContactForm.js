import React, { useState } from 'react'
import axios from 'axios';
import { useForm } from "react-hook-form";


export default function ContactForm({parentCallback}) {
    const [messageSucess, messageError] = useState();
    const { register, handleSubmit, watch, formState: { errors }, getValues } = useForm();
    const onSubmit = data => 
        axios.post('api/contact', {
          subject : data.subject,
          message : data.message,
          email : data.email,
          
        }, 
         ).then((res) => { 
             parentCallback(res.data)
             
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
                   <label for='email'>Votre mail</label>
                   <input {...register("email" , { required: true, 
                                                   pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ })} 
                                                   className='form-control' id='email' />
                 
                   {errors.email && errors.email.type === "pattern" && <span>Entrez un email valide</span> }
               </div>
               
               <div className='form-group'>
                   <label for='subject'>Sujet</label>
                   <input {...register("subject" , { required: true })} className='form-control' id="subject"/>
                   {errors.subject && <span>This field is required</span>}
               </div>
               <div className='form-group'>
                   <label for='message'>Message</label>
                   <textarea {...register("message" , { required: true })} className='form-control' id="message"/>
                   {errors.message && <span>This field is required</span>}
               </div>
               
              
               <div className='form-group'>
            
                
                
                <input type="submit" className='btn btn-success' style={{ marginTop:"20px" }} />
                </div>
            </form>
            
        </>
    )
}
