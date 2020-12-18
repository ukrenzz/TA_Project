import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Testing extends Component{
  render() {
    return (
      <div>
        Testing Project Neko
      </div>
    )
  }
}

ReactDOM.render(<Testing />, document.getElementById('root'));
