import { cva } from 'class-variance-authority';

export const cardVariants = cva(
  'rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 text-card-foreground shadow'
);

export { default as Card } from './card/Card.vue';
export { default as CardHeader } from './card/CardHeader.vue';
export { default as CardTitle } from './card/CardTitle.vue';
export { default as CardDescription } from './card/CardDescription.vue';
export { default as CardContent } from './card/CardContent.vue';
export { default as CardFooter } from './card/CardFooter.vue';