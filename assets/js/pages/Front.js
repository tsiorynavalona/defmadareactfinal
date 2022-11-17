import React, {Component} from 'react';
class Home extends Component {
    render() {
        return (
            <div>
                <header class="masthead">
                    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h2 class="mx-auto my-0 text-uppercase">Déforestation madagascar</h2>
                                <p class="text-white-50 mx-auto mt-2 mb-5">Les forêts peuvent fournir 30% de la solution pour maintenir le réchauffement climatique en dessous de 2°C
                                </p>

                            </div>
                        </div>
                    </div>
                </header>
                <div class="info">
                    <h4 align="center">Les forêts de Madagascar sont reconnues pour la diversité de leur faune et de leur flore uniques :
                                                                                                        l'île abrite 5% des espèces du monde.</h4>
                    <p class="text-black-50 mb-0">Madagascar est classé parmi les « hot spot » de la biodiversité mondiale. La variété des climats, conjuguée à celle des reliefs, a favorisé le développement d’une faune et d’une flore uniques au monde. La biodiversité de Madagascar est aujourd’hui largement menacée par les activités anthropiques, notamment la déforestation, et les ressources exceptionnelles de l’Ile attisent les convoitises (secteur minier,
                                            pierres et minerais précieux, bois précieux, etc.)</p>


                </div>
            </div>
        )

    }
}
export default Home;