import * as React from "react";
import { List, Datagrid, TextField, NumberField, ReferenceField } from 'react-admin';

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