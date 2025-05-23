import React from 'react';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

function Admin() {
  return (
    <div className="container">
      <h1 className="my-4">Admin Dashboard</h1>
      <div className="list-group">
        <Link to="/adminMaintenances" className="list-group-item list-group-item-action">
          Admin Maintenances
        </Link>
        <Link to="/adminUser" className="list-group-item list-group-item-action">
          Admin User
        </Link>
      </div>
    </div>
  );
}

export default Admin;