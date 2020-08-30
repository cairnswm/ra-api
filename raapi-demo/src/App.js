import * as React from "react";
import { Admin, Resource, ListGuesser, EditGuesser, ShowGuesser } from 'react-admin';
import dataProvider from './api/dataprovider';
import { UserList, UserEdit } from './components/user/user';

const App = () => (
	<Admin dataProvider={dataProvider}>
		<Resource name='users' list={UserList} edit={UserEdit} show={ShowGuesser} /> 
		<Resource name='level' list={ListGuesser} create={EditGuesser} edit={EditGuesser} show={ShowGuesser} /> 
	</Admin>
);

export default App;
