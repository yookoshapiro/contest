import { AxiosError, AxiosStatic, default as axios } from 'axios';
import { Api as ApiInterface, RouteParameter } from '../interface/Api';
import { AuthStore } from "../store/auth";
import { router } from "../router/routes";

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


    protected config()
    {

        let auth = AuthStore();

        return {
            headers: {
                Authorization: 'Bearer ' + auth.auth.token
            },
        };

    }

    public onUnauthorized(error: AxiosError): void
    {
        if( error.response?.status === 401 )
        {
            let auth = AuthStore();

            auth.auth.token = undefined;
            router.replace({name: 'login'});

        }
    }

    public list(path: string, parameter?: RouteParameter): Promise<any> {
        return this.handler.get(this.getUrl(path, parameter), this.config()).catch(this.onUnauthorized);
    }

    public find(path: string, id: string|number): Promise<any> {
        return this.handler.get(this.getUrl(path) + '/' + id, this.config()).catch(this.onUnauthorized);
    }

    public add(path: string, data: object): Promise<any> {
        return this.handler.post(this.getUrl(path), data, this.config()).catch(this.onUnauthorized);
    }

    public edit(path: string, id: string|number, data: object): Promise<any> {
        return this.handler.patch(this.getUrl(path) + '/' + id, data, this.config()).catch(this.onUnauthorized);
    }

    public remove(path: string, id: string|number): Promise<any> {
        return this.handler.delete(this.getUrl(path + '/' + id), this.config()).catch(this.onUnauthorized);
    }

    public login(login: string, password: string): Promise<any> {
        return this.handler.post(this.getUrl('auth/login'), {name: login, password});
    }

    public logout(token: string): Promise<any> {
        return this.handler.post(this.getUrl('auth/logout'), {token});
    }

    public validate(): Promise<any> {
        return this.handler.get(this.getUrl('auth/validate'), this.config());
    }

}

export default new Api;