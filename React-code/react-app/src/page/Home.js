import React, {useState, useEffect} from 'react'
import api from '../api'
import Footer from '../components/Footer'
import Form from '../components/Form'
import Header from '../components/Header'

const Home = () => {

  const [nodeData, setNodeData] = useState([])
  const [loading, setLoading] = useState(false)

  useEffect(() => {
    const getNodeData = async() => {
      const endPoint = '/jsonapi/node/uhd/9d28def4-69d6-4f5d-8522-ae61bbafe1c3';
      await api.getApiData(endPoint)
      .then((response)=>{
        setNodeData([response.data])
        //console.log(response.data)
        setLoading(true)
      })
      .catch((error) => {
          console.log(error)
      })
    }

    const timer = setTimeout(() => {
      getNodeData();
    }, 100);

    return () => {
      clearTimeout(timer)
    }
    
  }, []);

  return (
    <div className='home'>
      <Header/>
      <section className="body">
        <div className="banner">
          <div className="col">
            <div className="container container-4">
              <div className="row">
                <div className="col-md-5 col-xs-12 col-md-offset-7">
                  <div className="form">
                    <div className="row-6 clearfix">
                      <img className="forma-1" src="images/forma_1.png" alt=""/>
                      <p className="text-2">request information</p>
                    </div>
                      <Form/>
                  </div>
                </div>
              </div>
            </div>
            <div className="shape-5-copy-2-holder">
              <div className="container">
                <div className="row">
                  <div className="col-xs-12">
                    <p className="text-5">The First Step in Your Life-Changing Experience</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {nodeData.map((node) => {
          return (
            <div key={node.id} className="container container-6">
              <div className="row">
                <div className="col-xs-12">
                  <div className="col-data-wrapper-2">
                    <div className="why-choose">              
                      <div className="text-6">                    
                        <div className="post-card" key={node.id}>
                          <div dangerouslySetInnerHTML={{__html: node.attributes.body.processed}} />
                        </div>
                      </div>
                      <div className="shape-30-copy-holder">
                        <img className="layer-3" src="images/layer_3.jpg" alt=""/>
                      </div>
                      
                    </div>
                    <div className="courses">
                      <p className="text-8">Featured Degrees at UHD</p>
                      <p className="text-9">UHD’s high-caliber undergraduate and graduate degree programs were designed with your busy life in mind. Whether you’re returning to finish your degree or launching an entirely new direction, you’ll find the flexibility and support you need here.</p>
                      <div className="row row-9 auto-clear match-height-bootstrap-row">
                        <div className="col-md-3 col-sm-6 col-xs-12">
                          <div className="shape-31-copy-5-holder">
                            Business
                          </div>
                        </div>
                        <div className="col-md-3 col-sm-6 col-xs-12">
                          <div className="shape-31-copy-9-holder">
                            Completion
                          </div>
                        </div>
                        <div className="col-md-3 col-sm-6 col-xs-12">
                          <div className="shape-31-copy-6-holder">
                            Criminal Justice
                          </div>
                        </div>
                        <div className="col-md-3 col-sm-6 col-xs-12">
                          <div className="shape-31-copy-7-holder">
                            Education
                          </div>
                        </div>
                      </div>
                      <div className="row auto-clear match-height-bootstrap-row">
                        <div className="col-md-4 col-xs-12">
                          <div className="shape-31-copy-9-holder-2">
                            Humanities &amp; Social Sciences
                          </div>
                        </div>
                        <div className="col-md-4 col-xs-12">
                          <div className="shape-31-copy-8-holder">
                            Public Service
                          </div>
                        </div>
                        <div className="col-md-4 col-xs-12">
                          <div className="shape-31-copy-10-holder">
                            Science
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="wrapper-2">
              <div className="container">
                <div className="row">
                  <div className="col-xs-12">
                    <div className="col-data-wrapper-3">
                      <div className="shape-7-copy-5"></div>
                      <div className="shape-7-copy-6"></div>
                      <img className="rectangle-1" src="images/rectangle_1.png" alt=""/>
                      <img className="rectangle-1-copy" src="images/rectangle_1.png" alt=""/>
                      <img className="rectangle-1-copy-2" src="images/rectangle_1.png" alt=""/>
                      <p className="text-13">With the lowest tuition of any university in Houston, UHD provides an excellent education at an affordable rate, freeing up your income while in school, and leaving you with less debt after graduation. Our goal is to make the financial part of education as stress-free as possible so you focus on earning your degree.</p>
                      <p className="text-14">Work-life balance can be tough. That’s why we offer a wide range of day, evening, weekend, online and hybrid course options to fit every schedule. UHD ranks #22 among top colleges for adults returning to school according to Best College Reviews. With locations across Houston and online, we can fit any schedule!</p>
                      <p className="text-16">UHD ranks as one of the best Texas universities based on alumni salary. First-year earnings of UHD grads are the third highest in the state according to College Measures. A degree from UHD will set you up with a strong earning potential.</p>
                      <img className="layer-19-copy-7" src="images/layer_19_copy_7.png" alt=""/>
                      <img className="layer-19-copy-8" src="images/layer_19_copy_7.png" alt=""/>
                      <p className="affordability">Affordability</p>
                      <p className="flexibility">Flexibility</p>
                      <p className="text-17">Earning Ability</p>
                      <p className="text-15">Why Choose UHD?</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          );
        })}
      </section>
      <Footer/>
    </div>
  )
}

export default Home
