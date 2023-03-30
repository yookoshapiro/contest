export interface Api
{

    list(path: string, parameter?: RouteParameter): Promise<any>;

    find(path: string, id: string|number): Promise<any>;

    add(path: string, data: object): Promise<any>;

    edit(path: string, id: string|number, data: object): Promise<any>

    remove(path: string, id: string|number): Promise<any>;

}


export interface Route
{

    name: string;

}


export interface RouteParameter
{

    limit?: number;

}