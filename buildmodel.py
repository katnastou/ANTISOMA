from modeller import *
from modeller.automodel import *    # Load the automodel class

log.verbose()
env = environ()
#env.io.hetatm = True
# directories for input atom files

a = automodel(env, alnfile = 'alignment.ali',
              		knowns = ('newpdb'), sequence = 'target')
a.starting_model= 1
a.ending_model  = 1
#a.md_level=refine.fast
a.make()