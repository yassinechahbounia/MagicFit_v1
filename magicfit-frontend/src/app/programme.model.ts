export interface Exercice {
  id: number;
  nom: string;
  description: string;
  image: string;
}

export interface Programme {
  id: number;
  nom: string;
  description: string;
  image: string;
  categorie: string;
  objectifs?: string;
  action?: string;
  exercices: Exercice[];   // Liste d'exercices enrichis
  nutrition: string[];     // Liste de conseils nutritionnels
}
