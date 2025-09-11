import { RouteParamsWithQueryOverload, RouteParams } from 'ziggy-js';

declare global {
  interface Window {
    confirm: (message: string) => boolean;
  }
  
  function route(): string;
  function route(name: string, params?: RouteParamsWithQueryOverload | RouteParams): string;
}