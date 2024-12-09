import React from 'react';
import { useLocation } from 'react-router-dom';

const withLocation = (WrappedComponent) => {
  return (props) => {
    const location = useLocation();
    return <WrappedComponent {...props} location={location} />;
  };
};

export default withLocation;
