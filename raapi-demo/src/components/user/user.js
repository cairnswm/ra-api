import * as React from "react";
import { List, Edit, Datagrid, TextField, NumberField, ReferenceField, 
            SimpleForm, TextInput, NumberInput, ReferenceInput, SelectInput } from 'react-admin';

export const UserList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="id" />
            <TextField source="name" />
            <TextField source="address" />
            <NumberField source="age" />
            <NumberField source="level" />
            <ReferenceField source="level" reference="level">
                <TextField source="name" />
            </ReferenceField>
        </Datagrid>
    </List>
);

export const UserEdit = props => (
    <Edit {...props}>
        <SimpleForm>
            <TextInput source="name" />
            <TextInput source="address" />
            <NumberInput source="age" />
            <ReferenceInput source="level" reference="level">
                <SelectInput optionText="name" />
            </ReferenceInput>
        </SimpleForm>
    </Edit>
);