import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../../api/Api';

export const teamsStore = defineStore('teams', {

    state: () => ({
        teams: Array()
    }),

    actions: {

        async load(): Promise<any>
        {

            return api.list('team')
                .then((response: AxiosResponse<any>) => {
                    this.teams = response.data.data;
                });

        },


        async find(id: string|number): Promise<any>
        {

            let teams = this.teams.filter((team) => {
                return team.id === id;
            });

            if (teams.length > 0)
            {

                return new Promise<any>((resolve) => {
                    resolve({data: {data: teams[0]}});
                });

            }

            return api.find('team', id);

        },


        async add(name: string): Promise<any>
        {

            return api.add('team', {name})
                .then((response: AxiosResponse<any>) =>
                {

                    let newTeam = response.data.data;
                    this.teams.push({id: newTeam.id, name});

                    return response;

                });

        },


        async edit(id: string, name: string): Promise<any>
        {

            return api.edit('team', id, {name})
                .then((response: AxiosResponse<any>) =>
                {

                    let index = this.teams.findIndex(team => team.id === id);
                    let team = this.teams[ index ];

                    team.name = name;

                    this.teams[ index ] = team;

                    return response;

                });

        },


        async remove(id: string): Promise<any>
        {

            return api.remove('team', id)
                .then((response: AxiosResponse<any>) =>
                {

                    let index = this.teams.findIndex(team => team.id === id);

                    if (index > -1) {
                        this.teams.splice(index, 1);
                    }

                    return response;

                });

        }

    }

});