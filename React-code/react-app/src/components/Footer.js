import React from 'react'
import { Link } from 'react-router-dom';

const gotoTop = () => {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
      });
}  

const Footer = () => {
  return (
    <section className="footer">        
        <div className="row-3-2">
          <div className="container">
            <div className="row">
              <div className="col-md-5 col-xs-12">
                <p className="text-18">© University of Houston-Downtown 2016 | All Rights Reserved.</p>
              </div>
              <div className="col-md-4 col-xs-12 col-md-offset-3">
                <div className="col-data-wrapper-4 clearfix">
                  <p className="text-19"><Link to='/'>Home</Link> | <Link to='/'>Degree Programs</Link></p>
                  <div className="col-2 top" onClick={() => gotoTop()}>
                    <img className="shape-14" src="images/shape_14.png" alt=""/>
                    <p className="top-2">TOP</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  )
}

export default Footer
