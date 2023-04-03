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

    public list(path: string, parameter?: RouteParameter): Promise<any> {
        return this.handler.get(this.getUrl(path, parameter))
    }

    public find(path: string, id: string|number): Promise<any> {
        return this.handler.get(this.getUrl(path) + '/' + id);
    }

    public add(path: string, data: object): Promise<any> {
        return this.handler.post(this.getUrl(path), data);
    }

    public edit(path: string, id: string|number, data: object): Promise<any> {
        return this.handler.patch(this.getUrl(path) + '/' + id, data);
    }

    public remove(path: string, id: string|number): Promise<any> {
        return this.handler.delete(this.getUrl(path + '/' + id));
    }

    public login(login: string, password: string): Promise<any> {
        return this.handler.post(this.getUrl('auth/login'), {name: login, password});
    }

    public logout(token: string): Promise<any> {
        return this.handler.post(this.getUrl('auth/logout'), {token});
    }

}

export default new Api;