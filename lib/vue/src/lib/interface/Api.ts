export interface Api
{

    request(method: string, path: string, parameter?: RouteParameter): Promise<any>;

    list(path: string, parameter?: RouteParameter): Promise<any>;

}


export interface Route
{

    name: string;

}


export interface RouteParameter
{

    limit: number;

}