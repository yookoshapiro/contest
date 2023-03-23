import { AxiosStatic, AxiosResponse } from 'axios';

export default class Route
{

    public name: string = "";

    protected url: string;

    protected handler: AxiosStatic;


    constructor(url: string, handler: AxiosStatic)
    {

        this.url = url;
        this.handler = handler;

    }


    public getUrl(route: string, parameter: Object|null): string
    {

        if (parameter === null) {
            return this.url + route;
        }

        let p: string[] = [];

        if ('limit' in parameter) {
            p.push('limit=' + parameter.limit)
        }

        return this.url + route + '?' + p.join('&');

    }


    public get(parameter: Object|null = null): Promise<any> {
        return this.handler.get( this.getUrl(this.name, parameter) );
    }

}