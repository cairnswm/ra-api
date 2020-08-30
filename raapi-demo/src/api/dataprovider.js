import { fetchUtils } from 'react-admin';
import { stringify } from 'query-string';

const apiUrl = 'http://localhost/raapi/api.php/';
const httpClient = fetchUtils.fetchJson;

export default {
    getList: (resource, params) => {
        console.log("GetList",resource,params);
        const { page, perPage } = params.pagination;
        const { field, order } = params.sort;
        const query = {
            sort: JSON.stringify([field, order]),
            range: JSON.stringify([(page - 1) * perPage, page * perPage - 1]),
            filter: JSON.stringify(params.filter),
        };
        const url = `${apiUrl}/${resource}?${stringify(query)}`;

        return httpClient(url).then(({ headers, json }) => {
            return ({
            data: json,
            total: parseInt(headers.get('content-range').split('/').pop(), 10),
        })});

        // return httpClient(url).then(data => {
        //     console.log("Data",data);
        //     console.log("Headers",data.headers);
        //     console.log("json",data.json);
        //     let xyz =  {
        //         data: data.json,
        //         header: data.headers.get('content-range'),
        //         total: parseInt(data.headers.get('content-range').split('/').pop(), 10),
        //     };
        //     console.log("XYZ",xyz);
        //     return xyz;
        // });
    },

    getOne: (resource, params) => {
        console.log("Get",resource,params);
        const url = `${apiUrl}/${resource}/${params.id}`;
        console.log("url",url);
        return httpClient(url)
        .then(({ json }) => {
            console.log("getOne data",json);
            return ({ data: json, })
        }
        )
    },


    getMany: (resource, params) => {
        
        console.log("GetMany",resource,params);
        const query = {
            filter: JSON.stringify({ id: params.ids }),
        };
        const url = `${apiUrl}/${resource}?${stringify(query)}`;
        return httpClient(url).then(({ json }) => ({ data: json }));
    },

    getManyReference: (resource, params) => {
        
        console.log("GetManyReference",resource,params);
        const { page, perPage } = params.pagination;
        const { field, order } = params.sort;
        const query = {
            sort: JSON.stringify([field, order]),
            range: JSON.stringify([(page - 1) * perPage, page * perPage - 1]),
            filter: JSON.stringify({
                ...params.filter,
                [params.target]: params.id,
            }),
        };
        const url = `${apiUrl}/${resource}?${stringify(query)}`;

        return httpClient(url).then(({ headers, json }) => ({
            data: json,
            total: parseInt(headers.get('content-range').split('/').pop(), 10),
        }));
    },

    update: (resource, params) => {
        
        console.log("update",resource,params);
        return httpClient(`${apiUrl}/${resource}/${params.id}`, {
            method: 'PUT',
            body: JSON.stringify(params.data),
        }).then(({ json }) => ({ data: json }))
    },

    updateMany: (resource, params) => {
        console.log("updateMany",resource,params);
        const query = {
            filter: JSON.stringify({ id: params.ids}),
        };
        return httpClient(`${apiUrl}/${resource}?${stringify(query)}`, {
            method: 'PUT',
            body: JSON.stringify(params.data),
        }).then(({ json }) => ({ data: json }));
    },

    create: (resource, params) => {
        
        console.log("Create",resource,params);
        return httpClient(`${apiUrl}/${resource}`, {
            method: 'POST',
            body: JSON.stringify(params.data),
        }).then(({ json }) => ({
            data: { ...params.data, id: json.id },
        }))
    },

    delete: (resource, params) => {
        console.log("delete",resource,params);
        return httpClient(`${apiUrl}/${resource}/${params.id}`, {
            method: 'DELETE',
        }).then(({ json }) => ({ data: json }))
    },

    deleteMany: (resource, params) => {
        console.log("deleteMany",resource,params);
        const query = {
            filter: JSON.stringify({ id: params.ids}),
        };
        return httpClient(`${apiUrl}/${resource}?${stringify(query)}`, {
            method: 'DELETE',
            body: JSON.stringify(params.data),
        }).then(({ json }) => ({ data: json }));
    }
};