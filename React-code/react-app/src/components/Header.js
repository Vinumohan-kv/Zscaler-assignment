import React from 'react'
import { Link } from 'react-router-dom';

const Header = () => {
  return (
    <div>
      <section className="on-hours-header">
        <div className="row-5">
          <div className="container">
            <div className="row">
              <div className="col-md-4 col-xs-12">
                <img className="uhd-logo-horizontal" src="images/uhd_logo-horizontal.png" alt="" />
              </div>
              <div className="col-md-8 col-xs-12">
                <p className="form-heading">Call <strong className="text-style">713-221-8522</strong> 
                to speak to an Admissions Counselor or complete the form below to learn more!
                </p>
              </div>
            </div>
          </div>
        </div>
        <div className="menu">
          <div className="shape-1-copy-2"></div>
          <div className="row-2-2">
            <div className="shape-3-copy-3"></div>
            <div className="container">
              <div className="row">
                <div className="col-md-4 col-xs-12">
                  <div className="col-data-wrapper clearfix">
                    <div className="shape-35-holder">
                    <Link to='/'>Home</Link>
                    </div>
                    <div className="shape-3-copy"></div>
                    <div className="group-1 clearfix">
                      <p className="text"><Link to='/'>degree programs</Link></p>
                      <img className="shape-29-copy" src="images/shape_29_copy.png" alt="" />
                    </div>
                    <div className="shape-3-copy-2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  )
}

export default Header
