import React from 'react';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

function AdminDashboard() {
  return (
    <div className="container">
      <h1 className="mt-4">Admin Dashboard</h1>
      <div className="list-group mt-3">
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

export default AdminDashboard;