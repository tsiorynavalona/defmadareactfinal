import React, { Component } from 'react'
import { Line } from "react-chartjs-2";
import {CategoryScale, LinearScale} from 'chart.js'; 
import Chart from 'chart.js/auto';
import moment from 'moment';
import 'chartjs-adapter-moment';
import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { number } from 'prop-types';

 class Stat extends Component {
   constructor(props) {
     super(props)
   
     this.state = {
       isLoading : false,
        year : 2022,
        month : 0,
        doleanceNumber : []
     }
   }

   changeDate = async (e) => {
      const nbs = []
      this.setState({
        isLoading : true,
        year : e.target.innerHTML
      })

      for (let i = 1; i <= 12; i++) {
        let nb  = await this.getDataTime(i, e.target.innerHTML).then(
          value => {
            return value.data
          }
        );
    //   sData.label.push(moment().year(this.state.year).month(12).date(i*7+1).startOf('day').format('MMMM-YYYY'))
        nbs.push(nb)
      
      }
      console.log(nbs)
      
      this.setState({
        doleanceNumber : nbs,
        isLoading : false
      })

      this.forceUpdate();
      
  }

  getDataTime = async (month, year = this.state.year) => {
    return axios.get(`api/doleance/nb?year=${year}&month=${month}`).then(
      this.setState({
        month : month,
        year : year
      })
    )
  }

  
    

  async componentDidMount() {
    this.setState(
      {
        isLoading : true
      }
    )
    const nbs = [];
    for (let i = 1; i <= 12; i++) {
      let nb  = await this.getDataTime(i, this.state.year).then(
        value => {
          return value.data
        }
      );
   //   sData.label.push(moment().year(this.state.year).month(12).date(i*7+1).startOf('day').format('MMMM-YYYY'))
      nbs.push(nb)
    
    }
    console.log(nbs)
    
    this.setState({
      doleanceNumber : nbs,
      isLoading : false
    })

    this.forceUpdate();

   

  }



  
    
    
    render() {

      let sData = {}
        sData.label = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
        sData.nb = this.state.doleanceNumber
        sData.label = sData.label.map(elem => `${elem} ${this.state.year}`)
        
        
        // sData.label = [2020, 2021, 2022]
        // sData.time = []
        let time_options = {
            scales: {
              y: {
                  type: 'linear',
                  min: 0,
                  ticks : {
                    stepSize: 1
                  }
              }
            },
            responsive: true,
            title: {
              display: false
            },
            legend: {
              display: false
            },
            tooltips: {
              callbacks: {
                label: function(tooltipItem, data){
                  return parseInt(tooltipItem.value)
                }
            },
            
          }
            
            
            
        }
        const data = {
            labels: sData.label,
           
            datasets: [
              {

                label: 'Nombre de doléance reçu',
                data: sData.nb,
                fill: true,
                backgroundColor: "rgba(70,192,70,0.2)",
                borderColor: "rgba(70,192,70,1)"
              }
                
            ]
          };

        
          Chart.register(CategoryScale)

        const chart = <Line data={data} options={time_options}  height={"100px"}/>

       
        return (
           
            <div className='container content'>
                <h1>Stat</h1>
                {this.state.isLoading ? (
                   <div className='fa-3x row'>
                           
                    <FontAwesomeIcon icon="spinner" pulse style={{ margin : '30px auto', color : 'green' }} />
                   </div>
                ) : (chart)}
                <div>
                
                  <button onClick={this.changeDate}>
                    2022
                  </button>
                  {this.buttonYaers}
                </div>
            </div>
        )
    }
}

export default Stat;
