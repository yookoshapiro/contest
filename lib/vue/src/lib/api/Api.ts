import { AxiosStatic, default as axios } from 'axios';
import { Api as ApiInterface, RouteParameter } from '../interface/Api';

class Api implements ApiInterface
{

    protected url: string = 'http://localhost/api/';

    protected handler: AxiosStatic = axios;

    protected getUrl(path: string, parameter?: RouteParameter): string
    {

        if (typeof parameter === "undefined") {
            return this.url + path;
        }

        let p: string[] = [];

        if ('limit' in parameter) {
            p.push('limit=' + parameter.limit);
        }

        return this.url + path + '?' + p.join('&');

    }

    public request(method: string, path: string, parameter?: RouteParameter): Promise<any>
    {

        return this.handler.request({
            method: method,
            url: this.getUrl(path, parameter)
        });

    }

    public list(path: string, parameter?: RouteParameter): Promise<any> {
        return this.request('get', path, parameter);
    }

}

export default new Api;