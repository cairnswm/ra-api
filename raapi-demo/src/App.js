import * as React from "react";
import { Admin, Resource, ListGuesser, EditGuesser, ShowGuesser } from 'react-admin';
import dataProvider from './api/dataprovider';

const App = () => (
	<Admin dataProvider={dataProvider}>
		<Resource name='users' list={ListGuesser} create={EditGuesser} edit={EditGuesser} show={ShowGuesser} /> 
	</Admin>
);

export default App;
