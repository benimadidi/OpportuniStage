import pygame, random

#initialise pygame
pygame.init()

#dimension
screen_width = 600
screen_height = 400
screen_size = (screen_width, screen_height)
taille_serpent = 10
taille_bloc_nourriture = 10
vitesse_serpent = 8

#couleurs
couleur_noir = (0,0,0)
couleur_verte = (84, 235, 29)
couleur_bleu = (50,153,213)
couleur_rouge = (230,4,29)

#initialise l'ecran
Windows_surface = pygame.display.set_mode(screen_size)
pygame.display.set_caption("Jeu du snake")

#Horloge pour gerer la vitesse du serpent
horloge = pygame.time.Clock()

#police
Arial_font = pygame.font.SysFont("arial", 25)
score_font = pygame.font.SysFont("comicsanms", 30)

#Fonction pour afficher le score 
def afficher_score(score) :
    valeur = score_font.render(f"Score : {str(score)}", True, couleur_rouge)
    Windows_surface.blit(valeur, [0,0])
    
#fonction pour dessiner le serpent 
def dessiner_serpent(taille_serpent, liste_serpent) :
    for x in liste_serpent :
        segment = pygame.Rect(x[0], x[1], taille_serpent, taille_serpent)
        pygame.draw.rect(Windows_surface, couleur_verte, segment )
        
# Fonction pour afficher le message
def message(msg, couleur) :
    mesg = Arial_font.render(msg, True, couleur)
    Windows_surface.blit(mesg, [screen_width / 6, screen_height / 3])
        
#Fonction principale du jeu 
def jeu() :
    game_over = False
    game_close = False

    #position initiale du serpent
    x1 = screen_width / 2
    y1 = screen_height / 2
    
    x1_change = 0
    y1_change = 0
    
    liste_serpent = []
    longueur_serpent = 1
    
    #generer la nourriture
    x_nourriture = round(random.randrange(0, screen_width - taille_bloc_nourriture) / 10) * 10.0
    y_nourriture = round(random.randrange(0, screen_height - taille_bloc_nourriture) / 10.0) * 10.0
    
    while not game_over :
        
        # boucle qui s'execute lorque le jeu est terminé
        while game_close :
            Windows_surface.fill(couleur_noir)
            message("Vous avez perdu! Appuyer sur C pour recommencer ou Q pour quitter", couleur_rouge)
            
            afficher_score(longueur_serpent - 1)
            pygame.display.update()
            
            for event in pygame.event.get() :
                if event.type == pygame.KEYDOWN :
                    if event.key == pygame.K_q :
                        game_over = True
                        game_close = False
                    if event.key == pygame.K_c :
                        jeu()
                        
        # Gestion des differents evenements pour les directions du serpent 
        for event in pygame.event.get() :
            if event.type == pygame.QUIT :
                game_over = True
            if event.type == pygame.KEYDOWN :
                if event.key == pygame.K_LEFT :
                    x1_change = - taille_serpent
                    y1_change = 0
                if event.key == pygame.K_RIGHT :
                    x1_change = taille_serpent
                    y1_change = 0
                if event.key == pygame.K_UP :
                    x1_change = 0
                    y1_change = -taille_serpent
                if event.key == pygame.K_DOWN :
                    x1_change = 0
                    y1_change = +taille_serpent
            
        if x1 >= screen_width or x1 < 0 or y1 >= screen_height or y1 < 0 :
            game_close = True
        x1 += x1_change
        y1 += y1_change
        Windows_surface.fill(couleur_noir)
        segment = pygame.Rect(x_nourriture, y_nourriture, taille_bloc_nourriture, taille_bloc_nourriture )
        pygame.draw.rect(Windows_surface, couleur_bleu, segment)
        liste_serpent.append([x1,y1])
        if len(liste_serpent) > longueur_serpent:
            del liste_serpent[0]
            
        for x in liste_serpent[:-1] :
            if x == [x1, y1] :
                game_close = True
                
        dessiner_serpent(taille_serpent, liste_serpent)
        afficher_score(longueur_serpent - 1)
        
        pygame.display.update()
        
        # Verifier si le serpent mange la nourriture
        if x1 == x_nourriture and y1 == y_nourriture :
            x_nourriture = round(random.randrange(0, screen_width - taille_bloc_nourriture) / 10.0) * 10.0
            y_nourriture = round(random.randrange(0, screen_height - taille_bloc_nourriture) / 10.0) * 10.0
            longueur_serpent += 1
            
        horloge.tick(vitesse_serpent)    
    
    pygame.quit()
    quit()
    
#Lancement du jeu 
jeu()        